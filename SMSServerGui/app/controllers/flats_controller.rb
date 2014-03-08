class FlatsController < ApplicationController
  # GET /users
  # GET /users.xml
  def index
    @flats = Flat.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @flats }
    end
  end

  # GET /users/1
  # GET /users/1.xml
  def show
    @flat = Flat.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @flat }
    end
  end

  # GET /users/new
  # GET /users/new.xml
  def new
    @flat = Flat.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @flat }
    end
  end

  # GET /users/1/edit
  def edit
    @flat = Flat.find(params[:id])
  end

  # POST /users
  # POST /users.xml
  def create
    @flat = Flat.new(params[:flat])

    respond_to do |format|
      if @flat.save
        flash[:notice] = 'Building was successfully created.'
        format.html { redirect_to(@flat) }
        format.xml  { render :xml => @flat, :status => :created, :location => @flat }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @flat.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /users/1
  # PUT /users/1.xml
  def update
    @flat = Flat.find(params[:id])

    respond_to do |format|
      if @flat.update_attributes(params[:flat])
        flash[:notice] = 'User was successfully updated.'
        format.html { redirect_to(@flat) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @flat.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /users/1
  # DELETE /users/1.xml
  def destroy
    @flat = Flat.find(params[:id])
    @flat.destroy

    respond_to do |format|
      format.html { redirect_to(flats_url) }
      format.xml  { head :ok }
    end
  end
end
