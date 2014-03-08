class FloorsController < ApplicationController
  # GET /floors
  # GET /floors.xml
  def index
    @floors = Floor.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @floors }
    end
  end

  # GET /users/1
  # GET /users/1.xml
  def show
    @floor = Floor.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @floor }
    end
  end

  # GET /users/new
  # GET /users/new.xml
  def new
    @floor = Floor.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @floor }
    end
  end

  # GET /users/1/edit
  def edit
    @floor = Floor.find(params[:id])
  end

  # POST /users
  # POST /users.xml
  def create
    @floor = Floor.new(params[:floor])

    respond_to do |format|
      if @floor.save
        flash[:notice] = 'Floor was successfully created.'
        format.html { redirect_to(@floor) }
        format.xml  { render :xml => @floor, :status => :created, :location => @floor }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @floor.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /users/1
  # PUT /users/1.xml
  def update
    @floor = Floor.find(params[:id])

    respond_to do |format|
      if @floor.update_attributes(params[:floor])
        flash[:notice] = 'User was successfully updated.'
        format.html { redirect_to(@floor) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @floor.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /floors/1
  # DELETE /floors/1.xml
  def destroy
    @floor = Floor.find(params[:id])
    @floor.destroy

    respond_to do |format|
      format.html { redirect_to(floors_url) }
      format.xml  { head :ok }
    end
  end
end
